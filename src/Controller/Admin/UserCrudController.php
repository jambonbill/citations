<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        //yield EmailField::new('email');
        yield IdField::new('id')
            ->hideOnForm();
            //->hideWhenCreating()
            ;

        yield EmailField::new('email');
        
        yield TextField::new('password')
            ->onlyOnForms();


        yield TextField::new('firstName')
            ->onlyOnForms();;
        
        yield TextField::new('lastName')
            ->onlyOnForms();;
        
        yield TextField::new('fullName')
            //->onlyOnIndex();
            ->hideOnForm();

        //yield BooleanField::new('verified');
        //    ->renderAsSwitch(false);
        
        //https://symfonycasts.com/screencast/easyadminbundle/field-config#play
        $roles=['ROLE_ADMIN','ROLE_SUPERADMIN','ROLE_MODERATOR'];
        yield ChoiceField::new('roles')
            ->setChoices(array_combine($roles, $roles))
            ->allowMultipleChoices()
            ->renderAsBadges();

        yield DateField::new('createdAt')
            ->hideOnForm();    
            //->setValue(new \DateTimeImmutable);
    
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        //https://symfonycasts.com/screencast/easyadminbundle/filters
        return parent::configureFilters($filters)->add('roles');
    }

}
