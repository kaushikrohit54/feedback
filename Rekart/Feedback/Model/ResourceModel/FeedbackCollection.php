<?php
declare(strict_types=1);

namespace Rekart\Feedback\Model\ResourceModel;

use Rekart\Feedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Rekart\Feedback\Model\Feedback as FeedbackModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class FeedbackCollection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(FeedbackModel::class, FeedbackResourceModel::class);
    }
}
