<?php

namespace UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('username')
            ->add('image')
            ->add('address')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $typeContext = array('Vendor' => 'vendor');
        
        if($this->isGranted('ROLE_SUPER_ADMIN')){
            $typeContext['Super-Admin'] = 'super-admin';
            $typeContext['Administrator'] = 'administrator';
        }
        
        $passwordRequired = (preg_match('/_edit$/', $this->getRequest()->get('_route'))) ? false : true;
        $formMapper
            ->with('Connection Information', array('class' => 'col-md-4'))
                ->add('email')
                ->add('plainPassword', 'repeated', array(
                        'type' => 'password',
                        'invalid_message' => 'The password fields must match.',
                        'required' => $passwordRequired,
                        'first_options'  => array('label' => 'Password'),
                        'second_options' => array('label' => 'Repeat Password'),
                    ))
                
            ->end()
                
        ->with('Profile information', array('class' => 'col-md-4'))
            ->add('username', null, array('label' => 'Name'))
            ->add('phoneNumber')
            ->add('address');
        
        
        if ($this->isGranted('EDIT')) {
            $formMapper->end()
            ->with('Security', array('class' => 'col-md-4'))
                ->add('type', 'choice', array('choices' => $typeContext,
                                              'expanded' => true))
            ->end();
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('image')
            ->add('address')
        ;
    }
    
    public function preValidate($object) {
        parent::preValidate($object);
        $object->setEnabled(true);
        
        switch ($object->getType()){
        case 'super-admin':
            $object->setRoles(array('ROLE_SUPER_ADMIN'));
        break;
        case 'administrator':
            $object->setRoles(array('ROLE_ADMIN'));
        break;
        case 'vendor':
            $object->setRoles(array('ROLE_VENDOR'));
        break;
    
        }
    }
}
