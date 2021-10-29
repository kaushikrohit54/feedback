<?php

declare(strict_types=1);

namespace Rekart\Feedback\Model;

use Rekart\Feedback\Api\Data\FeedbackInterface;
use Rekart\Feedback\Api\Data\FeedbackInterfaceFactory;
use Rekart\Feedback\Api\FeedbackRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

class CreateQueryFeedback
{

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var FeedbackRepositoryInterface
     */
    private $feedbackRepository;
    /**
     * @var FeedbackInterfaceFactory
     */
    private $feedbackFactory;

    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_general/email';
    protected $_transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $storeManager;
    protected $_escaper;

    /**
     * @param DataObjectHelper $dataObjectHelper
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param FeedbackInterfaceFactory $seedbackInterfaceFactory
     */
    public function __construct(
        DataObjectHelper $dataObjectHelper,
        FeedbackRepositoryInterface $feedbackRepository,
        FeedbackInterfaceFactory $feedbackInterfaceFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->dataObjectHelper = $dataObjectHelper;
        $this->feedbackRepository = $feedbackRepository;
        $this->feedbackFactory = $feedbackInterfaceFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
    }

    /**
     * @param array $data
     * @return FeedbackInterface
     * @throws GraphQlInputException
     */
    public function execute(array $data): FeedbackInterface
    {
        try {
            $this->vaildateData($data);
            $feedback = $this->createFeedback($data);
            $this->sendEmail($data);
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        return $feedback;
    }

    /**
     * Guard function to handle bad request.
     * @param array $data
     * @throws LocalizedException
     */
    private function vaildateData(array $data)
    {
        if (!isset($data[FeedbackInterface::NAME])) {
            throw new LocalizedException(__('Name must be set'));
        }
    }

    /**
     * @param array $data
     * @return FeedbackInterface
     * @throws CouldNotSaveException
     */
    private function createFeedback(array $data): FeedbackInterface
    {
        /** @var FeedbackInterface $feedbackDataObject */
        $feedbackDataObject = $this->feedbackFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $feedbackDataObject,
            $data,
            FeedbackInterface::class
        );

        $this->feedbackRepository->save($feedbackDataObject);

        return $feedbackDataObject;
    }

        /**
     * Guard function to handle bad request.
     * @param array $data
     * @throws LocalizedException
     */
    private function sendEmail(array $data)
    {
        // print_r($data['disclaimer']);

        $emailData = [
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'feedback' => $data['feedback'],
            'disclaimer' => $data['disclaimer']
        ];

        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($emailData);

        $this->inlineTranslation->suspend();
        try 
		{
			$error = false;
			$sender = [
				'name' => $this->scopeConfig->getValue('trans_email/ident_support/name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE),
				'email' => $this->scopeConfig->getValue('trans_email/ident_support/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE),
			];
            $email = 'developertestrohit@gmail.com';

			$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
			$transport = 
				$this->_transportBuilder
				->setTemplateIdentifier('feedback_admin_email') // Send the ID of Email template which is created in Admin panel
				->setTemplateOptions(
					['area' => \Magento\Framework\App\Area::AREA_ADMINHTML, // using frontend area to get the template file
					'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,]
				)
				->setTemplateVars(['data' => $postObject])
				->setFrom($sender)
				->addTo($email)
				->getTransport();
			$transport->sendMessage();
			$this->inlineTranslation->resume();
		} 
		catch (\Exception $e) 
		{
			\Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($e->getMessage());
		}
       
    }
}
