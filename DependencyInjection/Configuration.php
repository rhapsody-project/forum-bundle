<?php
/* Copyright (c) 2013 Rhapsody Project
 *
 * Licensed under the MIT License (http://opensource.org/licenses/MIT)
 *
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
 * KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Rhapsody\ForumBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Forum configuration
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\DependencyInjection
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rhapsody_forum');

        $supportedDrivers = array('orm', 'mongodb');
        $supportedFormats = array('bbcode', 'markdown');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('formatter')
                    ->validate()
                        ->ifNotInArray($supportedFormats)
                        ->thenInvalid('The format %s is not supported. Please choose one of '.json_encode($supportedFormats))
                    ->end()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('category_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('forum_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('post_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('topic_class')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('pagination')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('posts_per_page')->defaultValue(10)->end()
                        ->scalarNode('topics_per_page')->defaultValue(50)->end()
                        ->scalarNode('search_results_per_page')->defaultValue(10)->end()
                    ->end()
                ->end()
            ->end()
        ;

        $this->addForumFormSection($rootNode);
        $this->addPostFormSection($rootNode);
        $this->addTopicFormSection($rootNode);
        return $treeBuilder;
    }

    private function addForumFormSection(ArrayNodeDefinition $node)
    {
      $node
          ->children()
              ->arrayNode('forum')
                  ->addDefaultsIfNotSet()
                  ->canBeUnset()
                  ->children()
                      ->arrayNode('form')
                          ->addDefaultsIfNotSet()
                          ->children()
                              ->scalarNode('type')->defaultValue('rhapsody_forum_form_type_forum')->end()
                              ->scalarNode('name')->defaultValue('rhapsody_forum_forum_form')->end()
                              ->arrayNode('validation_groups')
                                  ->prototype('scalar')->end()
                                  ->treatNullLike(array())
                              ->end()
                          ->end()
                      ->end()
                  ->end()
              ->end()
          ->end()
      ;
    }

    private function addPostFormSection(ArrayNodeDefinition $node)
    {
      $node
          ->children()
              ->arrayNode('post')
                  ->addDefaultsIfNotSet()
                  ->canBeUnset()
                  ->children()
                      ->arrayNode('form')
                          ->addDefaultsIfNotSet()
                          ->children()
                              ->scalarNode('type')->defaultValue('rhapsody_forum_form_type_post')->end()
                              ->scalarNode('name')->defaultValue('rhapsody_forum_post_form')->end()
                              ->arrayNode('validation_groups')
                                  ->prototype('scalar')->end()
                                  ->treatNullLike(array())
                              ->end()
                          ->end()
                      ->end()
                  ->end()
              ->end()
          ->end()
      ;
    }

    private function addTopicFormSection(ArrayNodeDefinition $node)
    {
      $node
          ->children()
              ->arrayNode('topic')
                  ->addDefaultsIfNotSet()
                  ->canBeUnset()
                  ->children()
                      ->arrayNode('form')
                          ->addDefaultsIfNotSet()
                          ->children()
                              ->scalarNode('type')->defaultValue('rhapsody_forum_form_type_topic')->end()
                              ->scalarNode('name')->defaultValue('rhapsody_forum_topic_form')->end()
                              ->arrayNode('validation_groups')
                                  ->prototype('scalar')->end()
                                  ->treatNullLike(array())
                              ->end()
                          ->end()
                      ->end()
                  ->end()
              ->end()
          ->end()
      ;
    }
}
