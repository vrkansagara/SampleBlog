<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 12:47 AM
 */

namespace SampleBlog\Model;

interface PostInterface
{
    public function getId();

    public function getTitle();

    public function getText();

}