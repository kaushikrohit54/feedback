<?php

declare(strict_types=1);

namespace Rekart\Feedback\Model;

use Rekart\Feedback\Api\Data\FeedbackInterface;
use Rekart\Feedback\Api\FeedbackRepositoryInterface;
use Rekart\Feedback\Model\ResourceModel\Feedback as FeedbackResourceModel;
use Rekart\Feedback\Model\ResourceModel\FeedbackCollection;
use Rekart\Feedback\Model\ResourceModel\FeedbackCollectionFactory;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * @var FeedbackCollectionFactory
     */
    private $feedbackCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SearchResultsInterfaceFactory
     */
    private $feedbackSearchResultsInterfaceFactory;
    /**
     * @var FeedbackResourceModel
     */
    private $feedbackResourceModel;

    public function __construct(
        FeedbackCollectionFactory $feedbackCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SearchResultsInterfaceFactory $feedbackSearchResultsInterfaceFactory,
        FeedbackResourceModel $feedbackResourceModel
    ) {
        $this->feedbackCollectionFactory = $feedbackCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->feedbackSearchResultsInterfaceFactory = $feedbackSearchResultsInterfaceFactory;
        $this->feedbackResourceModel = $feedbackResourceModel;
    }


    /**
     * @inheritDoc
     */
    public function save(FeedbackInterface $feedback): void
    {
        try {
            $this->feedbackResourceModel->save($feedback);
            
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save Source'), $e);
        }
    }
}
