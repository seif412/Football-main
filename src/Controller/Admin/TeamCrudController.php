<?php

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $logoField = TextField::new('logoFile')
            ->setFormType(VichImageType::class)
            ->onlyOnForms(); 

        // If it's a new page, make the logo field required
        if ($pageName === Crud::PAGE_NEW) {
            $logoField->setRequired(true);
        }

        return [
            IdField::new('id')->hideOnForm(),
            $logoField,
            ImageField::new('logo')
                ->setBasePath('/uploads/team_logos/')
                ->hideOnForm(),
            TextField::new('name'),
            TextField::new('country'),
            TextField::new('city'),
        ];
    }
}
