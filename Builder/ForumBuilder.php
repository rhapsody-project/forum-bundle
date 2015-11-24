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
namespace Rhapsody\ForumBundle\Builder;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Builder
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ForumBuilder
{

  /**
   * The class to be instantiated by the builder.
   * @var string
   * @access protected
   */
  protected $class;

  /**
   * The object that is being built.
   * @var mixed
   * @access protected
   */
  protected $object;

  /**
   * The authorization checker class to be instantiated by the builder.
   * @var AuthorizationCheckerInterface
   * @access protected
   */
  protected $authorizationChecker;

  /**
   * The validator
   * @var ValidatorInterface
   * @access protected
   */
  protected $validator;


  /**
   *
   */
  public function __construct(AuthorizationCheckerInterface $authorizationChecker, $validator, $class)
  {
    $this->class = $class;
    $this->authorizationChecker = $authorizationChecker;
    $this->validator = $validator;

    $this->object = new $class();
  }

  public function build()
  {
    return $this->object;
  }

  public function setName($name)
  {
    $this->object->setName($name);
    return $this;
  }
}
