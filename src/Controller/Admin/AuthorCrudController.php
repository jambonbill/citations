<?php

namespace App\Controller\Admin;


use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;



use App\Entity\Author;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AuthorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Author::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();

        yield TextField::new('name')
            ->setLabel("Nom de l'auteur");
        
        yield TextField::new('bio')
            ->setLabel("Biographie")
            ->setHelp("Si jamais il y a kekchose d'interessant a dire");
        
        yield DateField::new('createdAt')
            ->onlyOnIndex()
            //->setValue(new \DateTimeImmutable)
            ->setHelp("Lol marche pas");
    }
    

    /*
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions);
    }
    */
}
