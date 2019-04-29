<?php
namespace App\Library\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class UserFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {


        if ($targetEntity->hasAssociation('deals') && $this->hasParameter('deals')) {

            return '('.$targetTableAlias.'.deal_id IN '.$this->getParameter('deals').')';
        }
        return '';
    }
}
