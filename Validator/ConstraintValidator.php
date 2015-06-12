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
namespace Rhapsody\ForumBundle\Validator;

use Rhapsody\ForumBundle\Model\AuthorAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The abstract validator tracks the forum classes that it supports so that
 * all validators may be associated with all builder factories, but only
 * the relevant validators applied during the final phase of building the
 * object.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Validator
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ConstraintValidator extends AbstractValidator
{

  private $constraints = array();

  public function __construct(array $constraints = null)
  {
    $this->constraints = $constraints;
  }

  public function addConstraint($constraint)
  {
    $this->constraints[] = $constraint;
  }

  /**
   * Performs the actual validation.
   *
   * @param mixed $object the object to validate.
   * @return boolean <tt>true</tt> if valid; otherwise <tt>false</tt>.
   */
  protected function doValidate($object)
  {
    try {
      foreach ($this->constraints as $constraint) {
        $constraint->evaluate($object);
      }
      return true;
    }
    catch (\Exception $ex) {
      //$this->log->warn()
    }
    return false;
  }

  /**
   * Tests to see if the <tt>$object</tt> is supported by this validator. If it
   * is, validation continues; if not, an exception is thrown indicating that
   * an invalid argument was passed to the validator.
   *
   * @param mixed $object the object to test for support.
   * @return boolean <tt>true</tt> if the <tt>$object</tt> is supported.
   * @throws \InvalidArgumentException if the <tt>$object</tt> is not supported
   *    by this validator.
   */
  protected function isSupported($object)
  {
    return true;
  }
}
