<?php
/**
 * Created by PhpStorm.
 * User: rmartinez
 * Date: 11/06/16
 * Time: 21:41
 */

namespace AppBundle\Security;

use AppBundle\Entity\Booking;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookingVoter extends Voter {

    const CREATE = "create";
    const VIEW = "view";
    const EDIT = "edit";
    const ADMIN = "admin";

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::CREATE, self::VIEW, self::EDIT, self::ADMIN])) {
            return false;
        }

        // only vote on Hostel objects inside this voter
        if (!$subject instanceof Booking) {
            return false;
        }
        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // you know $subject is a Booking object, thanks to supports
        /** @var Booking $booking */
        $booking = $subject;

        $user = $token->getUser();

        if(!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        switch($attribute) {
            case self::CREATE:
                return $this->canCreate($booking, $user);
            case self::VIEW:
                return $this->canView($booking, $user);
            case self::EDIT:
                return $this->canEdit($booking, $user);
            case self::ADMIN:
                return $this->canAdmin($booking, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canCreate(Booking $booking, User $user)
    {
        return true;
    }

    private function canView(Booking $booking, User $user)
    {
        return $booking->getUser()->getId() == $user->getId();
    }

    private function canEdit(Booking $booking, User $user)
    {
        return $booking->getUser()->getId() == $user->getId();
    }

    private function canAdmin(Booking $booking, User $user)
    {
        return $booking->getHostel()->getOwner()->getId() == $user->getId();
    }
}