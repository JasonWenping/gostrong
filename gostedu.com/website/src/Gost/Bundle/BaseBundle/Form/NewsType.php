<?php

namespace Gost\Bundle\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Gost\Bundle\BaseBundle\Entity\Channel;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
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
            ->add('title')
            ->add('content')
            ->add('channel', 'choice', $this->channelHash)
            ->add('source')
            ->add('author')
            ->add('thumbnail', 'file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gost\Bundle\BaseBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gost_bundle_basebundle_news';
    }
}
