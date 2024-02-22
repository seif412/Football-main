<?php

namespace App\Controller\Admin;

use App\Entity\Coach;
use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Doctrine\ORM\EntityManagerInterface;

class CoachCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Coach::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Initialize variable to hold the current team's ID
        $currentTeamId = null;

        // Retrieve the current entity being edited/created
        $currentEntity = $this->getContext()->getEntity()->getInstance();

        // Check if the current entity has a team associated
        if ($currentEntity && $currentEntity->getTeam()) {
            // If a team is associated, get its ID
            $currentTeamId = $currentEntity->getTeam()->getId();
        }

        // Retrieve teams without a coach using a custom repository method
        $teamsWithoutCoach = $this->entityManager->getRepository(Team::class)->findTeamsWithoutCoach($currentTeamId);

        // Configure fields to be displayed
        return [
            // Hide the ID field on the form
            IdField::new('id')->hideOnForm(),

            // Display a text field for entering coach's name
            TextField::new('name'),

            // Display an association field for selecting the team
            AssociationField::new('team')
                ->setRequired(false) // Allow the team to be optional
                ->setFormTypeOptions([
                    // Provide choices dynamically to exclude teams with coaches
                    'choices' => $teamsWithoutCoach,
                ]),
        ];
    }
}
