<?php
namespace App\Library\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class UserFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->hasAssociation('deals') && $this->hasParameter('deals')) {

            if (empty($this->reader)) {
                return '';
            }

            // The Doctrine filter is called for any query on any entity
            // Check if the current entity is "user aware" (marked with an annotation)
            $userAware = $this->reader->getClassAnnotation(
                $targetEntity->getReflectionClass(),
                'App\\Entity\\Annotation\\UserAware'
            );

            if (!$userAware) {
                return '';
            }

            $fieldName = $userAware->userFieldName;

            try {
                // Don't worry, getParameter automatically quotes parameters
                $userId = $this->getParameter('id');
            } catch (\InvalidArgumentException $e) {
                // No user id has been defined
                return '';
            }

            if (empty($fieldName) || empty($userId)) {
                return '';
            }

            $query = sprintf('%s.%s = %s', $targetTableAlias, $fieldName, $userId);

            return $query;

        }
        return '';
    }
}
