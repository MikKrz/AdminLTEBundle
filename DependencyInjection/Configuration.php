<?php

/*
 * This file is part of the AdminLTE bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminLTEBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('admin_lte_theme');

        $rootNodeChildren = $rootNode->children();
        $rootNodeChildren = $this->createSimpleChildren($rootNodeChildren, true);
        $rootNodeChildren = $this->createThemeChildren($rootNodeChildren);
        $rootNodeChildren = $this->createButtonChildren($rootNodeChildren);

        $rootNodeChildren->end();

        return $treeBuilder;
    }

    private function createWidgetTree($node)
    {
        $node->arrayNode('widget')
            ->children()
                ->scalarNode('collapsible_title')
                    ->defaultValue('Collapse')
                    ->info('')
                ->end()
                ->scalarNode('removable_title')
                    ->defaultValue('Remove')
                    ->info('')
                ->end()
                ->scalarNode('type')
                    ->defaultValue('primary')
                    ->info('')
                ->end()
                    ->booleanNode('bordered')
                    ->defaultTrue()
                    ->info('')
                ->end()
                    ->booleanNode('collapsible')
                    ->defaultFalse()
                    ->info('')
                ->end()
                ->booleanNode('removable')
                    ->defaultFalse()
                    ->info('')
                ->end()
                ->booleanNode('solid')
                    ->defaultTrue()
                    ->info('')
                ->end()
                ->booleanNode('use_footer')
                    ->defaultFalse()
                    ->info('')
                ->end()
        ->end();

        return $node;
    }

    private function createButtonChildren($rootNodeChildren)
    {
        $rootNodeChildren->arrayNode('button')
                        ->children()
                            ->scalarNode('type')
                                ->defaultValue('primary')
                                ->info('')
                            ->end()
                            ->scalarNode('size')
                                ->defaultFalse()
                                ->info('')
                            ->end()
                        ->end()
                    ->end();

        return $rootNodeChildren;
    }

    private function createSimpleChildren($rootNodeChildren, $withOptions = true)
    {
        if ($withOptions) {
            $optionChildren = $rootNodeChildren->arrayNode('options')
                 ->info('')
                 ->children();

            $optionChildren = $this->createSimpleChildren($optionChildren, false);
            $optionChildren = $this->createWidgetTree($optionChildren);
            $optionChildren = $this->createButtonChildren($optionChildren);
            $optionChildren = $this->createsubThemeChildren($optionChildren);

            $optionChildren->end();
        }

        $rootNodeChildren->arrayNode('knp_menu')
                        ->children()
                            ->scalarNode('enable')
                                ->defaultValue(false)
                                ->info('')
                            ->end()
                            ->scalarNode('main_menu')
                                ->defaultValue('avanzu_main')
                                ->info('your builder alias')
                            ->end()
                            ->scalarNode('breadcrumb_menu')
                                ->defaultFalse()
                                ->info('Your builder alias or false to disable breadcrumbs')
                            ->end()
                        ->end()
                    ->end();

        return $rootNodeChildren;
    }

    private function createThemeChildren($rootNodeChildren)
    {
        $themeChildren = $rootNodeChildren->arrayNode('theme')->children();

        $themeChildren = $this->createWidgetTree($themeChildren);
        $themeChildren = $this->createsubThemeChildren($themeChildren);
        $themeChildren->end()
            ->end();

        return $rootNodeChildren;
    }

    private function createsubThemeChildren($rootNodeChildren)
    {
        $rootNodeChildren->scalarNode('default_avatar')
                                ->defaultValue('bundles/avanzuadmintheme/img/avatar.png')
                            ->end()
                            ->scalarNode('skin')
                                ->defaultValue('skin-blue')
                                ->info('see skin listing for viable options')
                            ->end()
                            ->booleanNode('fixed_layout')
                                ->defaultFalse()
                            ->end()
                            ->booleanNode('boxed_layout')
                                ->defaultFalse()
                                ->info('these settings relate directly to the "Layout Options"')
                            ->end()
                            ->booleanNode('collapsed_sidebar')
                                ->defaultFalse()
                                ->info('described in the adminlte documentation')
                            ->end()
                            ->booleanNode('mini_sidebar')
                                ->defaultFalse()
                                ->info('')
                            ->end()
                            ->booleanNode('control_sidebar')
                                ->defaultFalse()
                                ->info('controls whether the right hand panel will be rendered')
                            ->end();

        return $rootNodeChildren;
    }
}
