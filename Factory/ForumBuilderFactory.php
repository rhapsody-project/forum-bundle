<?php
/* Copyright (c) 2015 Rhapsody Project
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
namespace Rhapsody\ForumBundle\Factory;

use Rhapsody\ForumBundle\Builder\ForumBuilder;
use Rhapsody\SocialBundle\Validator\ValidatorInterface;
use Rhapsody\SocialBundle\Factory\AbstractAuthorizationAwareFactory;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Document
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ForumBuilderFactory extends AbstractAuthorizationAwareFactory
{

  /**
   * Instantiates a new forum builder factory.
   *
   * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
   *    The security context.
   * @param \Rhapsody\SocialBundle\Validator\ValidatorInterface $validator
   *    The validator.
   * @param string $class
   *    The class to be created by the builder returned by the factory.
   */
  public function __construct(AuthorizationCheckerInterface $authorizationChecker, ValidatorInterface $validator, $class)
  {
      parent::__construct($authorizationChecker, $validator, $class);
  }

  /**
   * (non-PHPDoc)
   * @see \Rhapsody\SocialBundle\Factory\BuilderFactoryInterface::createBuilder()
   */
  public function createBuilder()
  {
    return new ForumBuilder($this->getSecurityContext(), $this->getValidator(), $this->getClass());
  }

}
