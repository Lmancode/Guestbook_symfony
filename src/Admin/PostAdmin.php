<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class PostAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('username')
            ->add('email')
            ->add('homepage')
            ->add('text')
            ->add('image')
            ->add('isDeleted')
            ->add('is_agree')
            ->add('user', null, ['label' => 'User'])
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('homepage')
            ->add('text')
            ->add('image')
            ->add('user_ip')
            ->add('user_agent')
            ->add('created_at')
            ->add('isDeleted')
            ->add('user')
            ->add('is_agree', 'boolean', ['label' => 'Agreed to show', 'editable' => true])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('username')
            ->add('email')
            ->add('homepage')
            ->add('text')
            ->add('image')
            ->add('isDeleted')
            ->add('is_agree')
            ->add('user')
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('homepage')
            ->add('text')
            ->add('image')
            ->add('user_ip')
            ->add('user_agent')
            ->add('created_at')
            ->add('isDeleted')
            ->add('is_agree')
            ;
    }
}
