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
namespace Rhapsody\ForumBundle\Controller;

use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rhapsody\ForumBundle\Form\Type\SearchType;
use Rhapsody\ForumBundle\Model\Search;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Controller
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ForumController extends Controller
{

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function createAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->container->get('rhapsody.forum.controller.delegate.forum_delegate');

		$response = $delegate->handle('create');
		return $response->render();
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function indexAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->container->get('rhapsody.forum.controller.delegate.forum_delegate');

		/** @var $delegate \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		$forum = $forumManager->findById($request->attributes->get('forum'));
		$response = $delegate->indexAction($request, $forum);
		return $response->render();
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function newAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\ForumDelegate */
		$delegate = $this->container->get('rhapsody.forum.controller.delegate.forum_delegate');

		$response = $delegate->handle('new');
		return $response->render();
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function searchAction(Request $request)
	{
		/** @var $paginator \Knp\Components\Pager\Paginator */
		$paginator = $this->get('knp_paginator');

		/** @var $postManager \Rhapsody\ForumBundle\Doctrine\PostManagerInterface */
		$postManager = $this->get('rhapsody.forum.doctrine.post_manager');

		$search = new Search();
		$form = $this->get('form.factory')->create(new SearchType(), $search);
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
		return $this->get('fos_rest.view_handler')->handle($view);
	}

}
