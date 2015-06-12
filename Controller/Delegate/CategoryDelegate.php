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
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DependencyInjection\ContainerAware;

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
class CategoryDelegate extends Delegate
{

	/**
	 * Delegate for forum category controllers.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 */
	public function listAction(Request $request)
	{
		$categories = $this->container->get('rhapsody.forum.doctrine.category_manager')->findAll();

		$view = View::create(array('categories' => $categories))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodyForumBundle:Category:list.html.twig');
		return $this->createResponseBuilder($view);
	}

	public function showAction(Request $request, ForumInterface $forum)
	{
		$page  = $request->query->get('page', 1);

		$view = View::create(array('category' => $category, 'page' => $page))
			->setFormat($request->getRequestFormat('html'))
			->setTemplate('RhapsodyForumBundle:Category:show.html.twig');
		return $this->createResponseBuilder($view);
	}

}
