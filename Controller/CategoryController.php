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
class CategoryController extends Controller
{

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function listAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\CategoryDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.category_delegate');

		return $delegate->listAction($request);
	}

	/**
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function showAction(Request $request)
	{
		/** @var $delegate \Rhapsody\ForumBundle\Controller\Delegate\CategoryDelegate */
		$delegate = $this->get('rhapsody.forum.controller.delegate.category_delegate');

		/** @var $delegate \Rhapsody\ForumBundle\Doctrine\ForumManagerInterface */
		$forumManager = $this->get('rhapsody.forum.doctrine.forum_manager');

		/** @var $delegate \Rhapsody\ForumBundle\Doctrine\CategoryManagerInterface */
		$categoryManager = $this->get('rhapsody.forum.doctrine.category_manager');

		$forum = $forumManager->findById($request->attributes->get('forum'));
		$category = $categoryManager->findBySlug($request->attributes->get('slug'));
		return $delegate->showAction($request, $forum, $category);
	}

}