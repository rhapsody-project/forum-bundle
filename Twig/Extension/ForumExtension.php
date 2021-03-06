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
namespace Rhapsody\ForumBundle\Twig\Extension;

use Rhapsody\ComponentExtensionBundle\Routing\RouteTranslatorInterface;
use Rhapsody\SocialBundle\Factory\FormatterFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Twig\Extension
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ForumExtension extends \Twig_Extension
{

	/**
	 * The service container.
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	private $container;

	/**
	 * The formatter factory.
	 * @var \Rhapsody\ForumBundle\Factory\FormatterFactoryInterface
	 */
	private $formatterFactory;

	/**
	 * The request stack.
	 * @var \Symfony\Component\HttpFoundation\RequestStack
	 */
	private $requestStack;

	private $routeTranslator;

	/**
	 *
	 */
	public function __construct(RequestStack $requestStack, FormatterFactoryInterface $formatterFactory, RouteTranslatorInterface $routeTranslator, ContainerInterface $container)
	{
		$this->container = $container;
		$this->formatterFactory = $formatterFactory;
		$this->requestStack = $requestStack;
		$this->routeTranslator = $routeTranslator;
	}

	public function getAtomFeedUrlForTopic($topic)
	{
		// TODO: Implement me!
		return '';
	}

	public function getCategoryClass($category)
	{
		$class = 'uncategorized';
		if ($category !== null && $category instanceof \Rhapsody\SocialBundle\Model\CategoryInterface) {
			$class = $category->getName();
		}
		return strtolower(trim($class));
	}

	public function getCategoryUrl($category)
	{
		// TODO: Implement me!
		return '';
	}

	/**
	 * Returns a list of global functions to add to the existing list.
	 *
	 * @return array An array of global functions
	 */
	public function getFunctions()
	{
		return array(

			new \Twig_SimpleFunction('rhapsody_forum_category_class',
				array($this, 'getCategoryClass'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_category_url',
				array($this, 'getCategoryUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_format_text',
				array($this, 'formatText'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_url',
				array($this, 'getForumUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_index_url',
				array($this, 'getForumIndexUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_post_create_url',
				array($this, 'getPostCreateUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_post_delete_url',
				array($this, 'getPostDeleteUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_post_edit_url',
				array($this, 'getPostEditUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_post_save_url',
				array($this, 'getPostSaveUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_post_url',
				array($this, 'getPostUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_topic_url',
				array($this, 'getTopicUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_topic_atom_feed_url',
				array($this, 'getAtomFeedUrlForTopic'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_topic_create_url',
				array($this, 'getTopicCreateUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_topic_new_url',
				array($this, 'getTopicNewUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_topic_reply_url',
				array($this, 'getTopicReplyUrl'),
				array('is_safe' => array('html'))
			),

			new \Twig_SimpleFunction('rhapsody_forum_topic_user_url',
				array($this, 'getTopicUserUrl'),
				array(
					'is_safe' => array('html')
			)),

			new \Twig_SimpleFunction('rhapsody_forum_user_url',
				array($this, 'getUserUrl'),
				array('is_safe' => array('html'))
			),
		);
	}

	public function getName()
	{
		return 'rhapsody_forum';
	}

	public function formatText($text)
	{
		$format = $this->container->getParameter('rhapsody_forum.formatter');

		$formatter = $this->formatterFactory->getFormatter($format);
		return $formatter->format($text);
	}

	public function getForumUrl($forum, $category = null)
	{
		$params = array('forum' => $forum->getId());
		if ($category !== null) {
			$params['category'] = $category->getSlug();
		}
		return $this->routeTranslator->translate('rhapsody_forum_view', $params, $this->getRoutingContext());
	}

	public function getForumIndexUrl()
	{
		return $this->routeTranslator->translate('rhapsody_forum', array(), $this->getRoutingContext());
	}

	public function getPostCreateUrl($topic)
	{
		$forum = $topic->getSocialContext();

		$params = array('forum' => $forum->getId(), 'topic' => $topic->getId());
		return $this->routeTranslator->translate('rhapsody_forum_post_create', $params, $this->getRoutingContext());
	}

	public function getPostDeleteUrl($post)
	{
		$forum  = $post->getSocialContext();
		$topic  = $post->getTopic();
		$params = array(
			'forum' => $forum->getId(),
			'topic' => $topic->getId(),
			'post'  => $post->getId()
		);
		return $this->routeTranslator->translate('rhapsody_forum_post_delete', $params, $this->getRoutingContext());
	}

	public function getPostEditUrl($post)
	{
		$forum  = $post->getSocialContext();
		$topic  = $post->getTopic();
		$params = array(
			'forum' => $forum->getId(),
			'topic' => $topic->getId(),
			'post'  => $post->getId()
		);
		return $this->routeTranslator->translate('rhapsody_forum_post_edit', $params, $this->getRoutingContext());
	}

	public function getPostSaveUrl($post)
	{
		$forum  = $post->getSocialContext();
		$topic  = $post->getTopic();
		$params = array(
			'forum' => $forum->getId(),
			'topic' => $topic->getId(),
			'post'  => $post->getId()
		);
		return $this->routeTranslator->translate('rhapsody_forum_post_save', $params, $this->getRoutingContext());
	}

	public function getPostUrl($post)
	{
		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		$forum = $post->getSocialContext();
		$topic = $post->getTopic();
		$page = $postManager->findPageByTopicAndPost($topic, $post);

		$params = array(
			'forum' => $forum->getId(),
			'topic' => $topic->getId(),
			'page' => $page
		);
		$url = $this->routeTranslator->translate('rhapsody_forum_topic_view', $params, $this->getRoutingContext());
		return $url.'#post-'.$post->id;
	}

	public function getRoutingContext()
	{
		$request = $this->requestStack->getMasterRequest();
		return $request->headers->get('X-SYMFONY-ROUTING-CONTEXT');
	}

	public function getTopicUrl($topic, $page = null)
	{
		$forum  = $topic->getSocialContext();
		$params = array('forum' => $forum->getId(), 'topic' => $topic->getId());
		if ($page !== null) {
			$params['page'] = $page;
		}
		return $this->routeTranslator->translate('rhapsody_forum_topic_view', $params, $this->getRoutingContext());
	}

	public function getTopicCreateUrl($forum, $category = null)
	{
		$params = array('forum' => $forum->getId());
		// TODO: Include post for quoting exercise...
		return $this->routeTranslator->translate('rhapsody_forum_topic_create', $params, $this->getRoutingContext());
	}

	public function getTopicNewUrl($forum, $category = null)
	{
		$params = array('forum' => $forum->getId());
		return $this->routeTranslator->translate('rhapsody_forum_topic_new', $params, $this->getRoutingContext());
	}

	public function getTopicReplyUrl($topic, $options = array())
	{
		$forum  = $topic->getSocialContext();
		$params = array('forum' => $forum->getId(), 'topic' => $topic->getId());
		// TODO: Include post for quoting exercise...
		return $this->routeTranslator->translate('rhapsody_forum_topic_reply', $params, $this->getRoutingContext());
	}

	public function getTopicUserUrl($topic, $user)
	{
		$forum = $topic->getSocialContext();
		$params = array(
			'forum' => $forum->getId(),
			'topic' => $topic->getId(),
			'u' => $user->getUsername()
		);
		return $this->routeTranslator->translate('rhapsody_forum_topic_view', $params, $this->getRoutingContext());
	}

	public function getUserUrl($user)
	{
		$params = array('user' => $user->getUsername());
		return $this->routeTranslator->translate('rhapsody_forum_user_view', $params, $this->getRoutingContext());
	}
}
