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
namespace Rhapsody\ForumBundle\Controller\Delegate;

use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Rhapsody\ForumBundle\Form\Type\SearchType;
use Rhapsody\ForumBundle\Model\Search;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Controller\Delegate
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ForumDelegate extends Delegate
{

	/**
	 *
	 * @return ResponseBuilderInterface the response builder.
	 */
	public function createAction(Request $request)
	{
		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->container->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.forum.form.factory');

		/** @var $forum \Rhapsody\ForumBundle\Model\ForumInterface */
		$forum = $forumManager->newForum();
		$form = $formFactory->createForm();
		$form->setData($forum);

		$view = View::create()
			->setData(array('form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodyForumBundle:Forum:new.html.twig');
		return $this->createResponseBuilder($view);
	}

	/**
	 *
	 * @return ResponseBuilderInterface the response builder.
	 */
	public function indexAction(Request $request)
	{
		$page = $request->query->get('page', 1);

		$view = View::create(array('page' => $page))
			->setFormat($request->getRequestFormat('html'))
			->setTemplate('RhapsodyForumBundle:Forum:index.html.twig');
		return $this->createResponseBuilder($view);
	}

	/**
	 *
	 * @return ResponseBuilderInterface the response builder.
	 */
	public function newAction(Request $request)
	{
		/** @var $forumManager \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->container->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('rhapsody_forum.forum.form.factory');

		/** @var $forum \Rhapsody\ForumBundle\Model\ForumInterface */
		$forum = $forumManager->newForum();
		$form = $formFactory->createForm();
		$form->setData($forum);

		$view = View::create()
			->setData(array('form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodyForumBundle:Forum:new.html.twig');
		return $this->createResponseBuilder($view);
	}

	public function searchAction(Request $request)
	{
		/** @var $paginator \Knp\Components\Pager\Paginator */
		$paginator = $this->container->get('knp_paginator');

		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->container->get('rhapsody.forum.doctrine.post_manager');

		$search = new Search();
		$form = $this->container->get('form.factory')->create(new SearchType(), $search);
		$form->bind(array('query' => $request->query->get('q')));
		$query = $form->getData()->getQuery();

		$results = array();
		if ($form->isValid()) {
				$results = $postManager->search($query, true);
		}
		$paginatedResults = $paginator->paginate($results, $request->query->get('page', 1),
				$this->container->getParameter('rhapsody_forum.pagination.search_results_per_page'));

		$view = View::create(array('form' => $form->createView(), 'results' => $paginatedResults, 'query' => $query))
			->setFormat($request->getRequestFormat('html'))
			->setTemplate('RhapsodyForumBundle:Forum:search.html.twig');
		return $this->container->get('fos_rest.view_handler')->handle($view);
	}

}
