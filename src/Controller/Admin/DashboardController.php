<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Quote;
use App\Entity\User;
use App\Repository\AuthorRepository;
use App\Repository\QuoteRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private AuthorRepository $authorRepository;
    private QuoteRepository $quoteRepository;
    
    public function __construct(QuoteRepository $quoteRepository, AuthorRepository $authorRepository)
    {
        $this->quoteRepository = $quoteRepository;
        $this->authorRepository = $authorRepository;
    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $latestQuotes = $this->quoteRepository->findLast();
        $latestAuthors = $this->authorRepository->findLast();
        
        return $this->render('admin/dashboard.html.twig',[
            'latestQuotes'=>$latestQuotes,
            'latestAuthors'=>$latestAuthors
        ]);

        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Citations Backoffice');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('', 'fa fa-home');
        //yield MenuItem::linkToDashboard('Dashboard2', 'fa fa-home');
        
        yield MenuItem::linkToCrud('Authors', 'fas fa-list', Author::class);
        yield MenuItem::linkToCrud('Quotes', 'fas fa-list', Quote::class);
        //yield MenuItem::linkToUrl("--","",'#');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class)
            ->setPermission('ROLE_ADMIN')
            ;
        
        
        yield MenuItem::linkToUrl("API","fas fa-code",'/api');   
        
        //yield MenuItem::linkToUrl("symfonycasts","",'https://symfonycasts.com/screencast/easyadminbundle/crud-controller#play');
        
        yield MenuItem::linkToUrl("--","",'#');
        
        yield MenuItem::linkToLogout("Logout","fa fa-sign-out");
    }

    public function configureUserMenu(\Symfony\Component\Security\Core\User\UserInterface $user):UserMenu
    {
        if (!$user instanceof User) {
            dd('?');
        }else{
            //dd($user);
        }

        return parent::configureUserMenu($user)
            ->setAvatarUrl('https://jambonbill.org/dist/img/jambonbill.png')
            //->setAvatarUrl($user->getAvatarUrl())
            ;
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureAssets(): Assets
    {
        //return Assets::new();
        return parent::configureAssets()
            //->addCssFile("foo.css")
            //->addHtmlContentToBody("<h1>HEAD</h1>")
            //->addHtmlContentToHead("<h1>BODY</h1>")
            
        ;
    } 

}
