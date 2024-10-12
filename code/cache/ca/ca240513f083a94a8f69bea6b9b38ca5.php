<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* user-index.tpl */
class __TwigTemplate_e985aae196a4762b95928949c96dfa4a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<p>Список пользователей в хранилище</p>

";
        // line 3
        if (($context["user_authorized"] ?? null)) {
            // line 4
            echo "    <a href=\"/user/edit/\">Create User</a>
";
        }
        // line 5
        echo "</li>

<ul id=\"navigation\">
    ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["users"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 9
            echo "        <li>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "getUserName", [], "method", false, false, false, 9), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "getUserLastName", [], "method", false, false, false, 9), "html", null, true);
            echo ". День рождения: ";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "getUserBirthday", [], "method", false, false, false, 9), "d.m.Y"), "html", null, true);
            echo "
        ";
            // line 10
            if (($context["user_authorized"] ?? null)) {
                // line 11
                echo "            <a href=\"/user/edit/?user_id=";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "getUserId", [], "any", false, false, false, 11), "html", null, true);
                echo "\">Edit</a>
        ";
            }
            // line 12
            echo "</li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "</ul>";
    }

    public function getTemplateName()
    {
        return "user-index.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 14,  73 => 12,  67 => 11,  65 => 10,  56 => 9,  52 => 8,  47 => 5,  43 => 4,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "user-index.tpl", "/data/mysite.local/src/Domain/Views/user-index.tpl");
    }
}
