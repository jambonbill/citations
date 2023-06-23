<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

use App\Entity\Quote;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


class QuoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quote::class;
    }

    
    
    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')
            ->setTextAlign('right')
            ->hideOnForm();
            
        yield TextField::new('data');
        yield TextField::new('info')        
            ->formatValue(static function($value, ?Quote $quote) {
                //return "<h2>$value</h2>";
                return $value;
            });
        
        yield AssociationField::new('author');
        
        yield DateField::new('createdAt')
            ->setTextAlign('right')
            ->hideOnForm();    
    }
    
}
