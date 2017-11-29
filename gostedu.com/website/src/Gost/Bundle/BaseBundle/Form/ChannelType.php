<?php

namespace Gost\Bundle\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChannelType extends AbstractType
{
    protected $channelHash;

    public function __construct(array $channel_hash) {
        $this->channelHash = $channel_hash;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('introduction')
            ->add('thumbnail', 'file')
            ->add('fid', 'choice', $this->channelHash)
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gost\Bundle\BaseBundle\Entity\Channel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gost_bundle_basebundle_channel';
    }
}
