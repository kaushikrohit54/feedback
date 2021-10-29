<?php
declare(strict_types=1);

namespace Rekart\Feedback\Model\Resolver;

use Rekart\Feedback\Model\CreateQueryFeedback as CreatQueryFeedbackService;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class CreatQueryFeedback implements ResolverInterface
{
    /**
     * @var CreatQueryFeedbackService
     */
    private $creatQueryFeedback;

    /**
     * @param CreatQueryFeedback $creatQueryFeedback
     */
    public function __construct(CreatQueryFeedbackService $creatQueryFeedback)
    {
        $this->creatQueryFeedback = $creatQueryFeedback;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }

        return [
            'feedback_submit' => $this->creatQueryFeedback->execute($args['input'])
        ];
    }
}
