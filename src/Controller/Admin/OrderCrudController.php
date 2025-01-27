<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\EntityManagerInterface;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Order')
            ->setEntityLabelInPlural('Orders')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user');
        yield ChoiceField::new('status')
            ->setChoices([
                'Pending' => Order::STATUS_PENDING,
                'Completed' => Order::STATUS_COMPLETED,
                'Cancelled' => Order::STATUS_CANCELLED,
            ])
            ->setRequired(true);
        yield MoneyField::new('total')
            ->setCurrency('EUR')
            ->setStoredAsCents(false)
            ->setFormTypeOptions([
                'data' => 0.0,
                'empty_data' => '0'
            ]);
        yield DateTimeField::new('createdAt')->hideOnForm();
    }

    public function createEntity(string $entityFqcn)
    {
        $order = new Order();
        $order->setTotal(0.0);
        return $order;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Order $entityInstance */
        if ($entityInstance->getTotal() === null) {
            $entityInstance->setTotal(0.0);
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Order $entityInstance */
        if ($entityInstance->getTotal() === null) {
            $entityInstance->setTotal(0.0);
        }
        parent::updateEntity($entityManager, $entityInstance);
    }
} 