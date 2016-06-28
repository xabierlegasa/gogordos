<?php

/* default/welcome.html.twig */
class __TwigTemplate_f3515804f9abb4e25ac029c6b4e2c8610c1a4cb7ba49461d314e5dd7dbfc69bd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "default/welcome.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "

    <div>
        hola
    </div>

    <br>
    <br>
    <br>
    <br>

";
    }

    public function getTemplateName()
    {
        return "default/welcome.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends 'base.html.twig' %}*/
/* */
/* {% block body %}*/
/* */
/* */
/*     <div>*/
/*         hola*/
/*     </div>*/
/* */
/*     <br>*/
/*     <br>*/
/*     <br>*/
/*     <br>*/
/* */
/* {% endblock %}*/
/* */
