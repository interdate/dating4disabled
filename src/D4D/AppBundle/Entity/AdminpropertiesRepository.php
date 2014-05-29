<?php
namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use D4D\AppBundle\Entity\Adminproperties;

class AdminpropertiesRepository extends EntityRepository{        

    public function getValue($settings){
        foreach ($settings as $setting){
            if($setting->getPropdisplaytype()=='s'){
                $valueArray = explode(';',$setting->getPropvalueslist());
                foreach($valueArray as $value){
                    $choice = explode('@',$value);
                    $choices[$choice[0]] = $choice[1];
                }
                $setting->value = $choices[$setting->getPropvalue()];
            }else{
                $setting->value = $setting->getPropvalue();
            }
        }
        return $settings;
    }
    
    public function addFormField($form, $setting){
        $type = $setting->getPropdisplaytype();
        $label = $setting->getPropdesc();
        switch ($type){
            case 't':
                $form->add('propvalue','text',array('label' => $label));
                break;
            case 'a':
                $form->add('propvalue','textarea',array('label' => $label));
                break;
            case 's':
                $valueArray = explode(';',$setting->getPropvalueslist());
                foreach($valueArray as $value){
                    $choice = explode('@',$value);
                    $choices[$choice[0]] = $choice[1];
                }
                $form->add('propvalue','choice',array(
                    'expanded'  => false,
                    'multiple'  => false,
                    'label'     => $label,
                    'choices'   => $choices));
                break;
        }
        
        return $form;
    }
    
}
?>
