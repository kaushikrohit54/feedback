<?php

declare(strict_types=1);

namespace Rekart\Feedback\Model;

use Rekart\Feedback\Api\Data\FeedbackInterface;
use Rekart\Feedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Magento\Framework\Model\AbstractExtensibleModel;

class Feedback extends AbstractExtensibleModel implements FeedbackInterface
{

    protected function _construct()
    {
        $this->_init(FeedbackResourceModel::class);
    }
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    public function getMobile(): ?string
    {
        return $this->getData(self::MOBILE);
    }

    public function setMobile(?string $mobile): void
    {
        $this->setData(self::MOBILE, $mobile);
    }

    public function getEmail(): ?string
    {
        return $this->getData(self::EMAIL);
    }

    public function setEmail(?string $email): void
    {
        $this->setData(self::EMAIL, $email);
    }

    public function getFeedback(): ?string
    {
        return $this->getData(self::FEEDBACK);
    }

    public function setFeedback(?string $feedback): void
    {
        $this->setData(self::FEEDBACK, $feedback);
    }

    public function getDisclaimer(): ?string
    {
        return $this->getData(self::DISCLAIMER);
    }

    public function setDisclaimer(?string $disclaimer): void
    {
        $this->setData(self::DISCLAIMER, $disclaimer);
    }

    public function getCreatedate(): ?string
    {
        return $this->getData(self::CREATEDATE);
    }

    public function setCreatedate(?string $create_date): void
    {
        $this->setData(self::CREATEDATE, $create_date);
    }
}
