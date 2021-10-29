<?php
declare(strict_types=1);

namespace Rekart\Feedback\Api;

use Rekart\Feedback\Api\Data\FeedbackInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface FeedbackRepositoryInterface
{
    /**
     * Save the Feedback data.
     *
     * @param \Magento\InventoryApi\Api\Data\SourceInterface $source
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(FeedbackInterface $feedback): void;

}
