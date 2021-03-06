<?php

/*
 * This file is part of the VinceType bundle.
 *
 * (c) Vincent Chalamon <http://www.vincent-chalamon.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\TypeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Router;

/**
 * Form type redactor
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class RedactorType extends AbstractType
{
    /**
     * Upload dir name
     *
     * @var string
     */
    protected $uploadDir;

    /**
     * Router
     *
     * @var Router
     */
    protected $router;

    /**
     * Set upload dir name
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param string $webDir    Path to web dir
     * @param string $uploadDir Path to upload dir
     */
    public function setUploadDirName($webDir, $uploadDir)
    {
        $this->uploadDir = str_ireplace($webDir, '', $uploadDir);
    }

    /**
     * Set router
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @param Router $router Router
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $paths = $options['paths'];
        unset($options['paths']);
        $view->vars['options'] = json_encode(array_merge(array(
                    'imageUpload' => $this->router->generate('redactor-upload'),
                    'fileUpload' => $this->router->generate('redactor-upload'),
                    'imageGetJson' => urldecode($this->router->generate('redactor-list-files').
                        '?'.http_build_query(array('paths' => $paths))),
                ), array_intersect_key($options, $this->getConfiguration())), JSON_UNESCAPED_SLASHES);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array_merge(array('paths' => array($this->uploadDir)), $this->getConfiguration()));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'redactor';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * Get configuration
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     *
     * @return array
     */
    protected function getConfiguration()
    {
        return array(
            'minHeight' => 200,
            'toolbar' => array(),
            'buttons' => array('html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'file', 'table', 'link', '|', 'alignment', '|', 'horizontalrule'),
            'buttonsAdd' => array(),
            'formattingTags' => array('p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4'),
            'buttonSource' => true,
            'iframe' => false,
            'fullpage' => false,
            'css' => false,
            'focus' => false,
            'shortcuts' => true,
            'autoresize' => true,
            'cleanup' => true,
            'toolbarFixed' => false,
            'toolbarFixedTopOffset' => 0,
            'toolbarFixedBox' => false,
            'toolbarFixedTarget' => 'document',
            'paragraphy' => true,
            'convertLinks' => true,
            'convertDivs' => true,
            'autosave' => false,
            'autosaveInterval' => 60,
            'modalOverlay' => true,
            'tabindex' => false,
            'observeImages' => true,
            'air' => false,
            'airButtons' => array('formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent'),
            'wym' => false,
            'mobile' => true,
            'linkProtocol' => 'http://',
            'placeholder' => false,
            'linebreaks' => false,
            'allowedTags' => false,
            'deniedTags' => array('html', 'head', 'link', 'body', 'meta', 'script', 'style', 'applet'),
            'boldTag' => 'strong',
            'italicTag' => 'em',
            'linkEmail' => false,
            'linkAnchor' => false,
            'formattingPre' => false,
            'phpTags' => false,
            'visual' => true,
            's3' => false,
            'tabFocus' => true,
            'removeEmptyTags' => true,
            'convertImageLinks' => false,
            'convertVideoLinks' => false,
            'pastePlainText' => false,
            'linkNoFollow' => false,
            'clipboardUpload' => true,
            'dragUpload' => true,
            'tidyHtml' => false,
            'imageFloatMargin' => '10px',
            'tabSpaces' => false,
            'observeLinks' => false,
            'plugins' => array(),
        );
    }
}
