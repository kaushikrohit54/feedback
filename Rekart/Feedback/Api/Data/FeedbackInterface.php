<?php

declare(strict_types=1);

namespace Rekart\Feedback\Api\Data;

/**
 * Represents a feedback and properties
 *
 * @api
 */
interface FeedbackInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const NAME = 'name';
    const MOBILE = 'mobile';
    const EMAIL = 'email';
    const FEEDBACK = 'feedback';
    const DISCLAIMER = 'disclaimer';
    const CREATEDATE = 'create_date';
    
    /**#@-*/

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getMobile(): ?string;

    public function setMobile(?string $mobile): void;

    public function getEmail(): ?string;

    public function setEmail(?string $email): void;

    public function getFeedback(): ?string;

    public function setFeedback(?string $feedback): void;

    public function getDisclaimer(): ?string;

    public function setDisclaimer(?string $disclaimer): void;
    
    public function getCreatedate(): ?string;

    public function setCreatedate(?string $create_date): void;
    
    
}
