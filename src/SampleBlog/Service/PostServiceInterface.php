<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 12:45 AM
 */

namespace SampleBlog\Service;

use SampleBlog\Model\PostInterface;

interface PostServiceInterface
{

    /**
     * Should return a set of all blog posts that we can iterate over. Single entries of the array are supposed to be
     * implementing \Blog\Model\PostInterface
     *
     * @return array|PostInterface[]
     */
    public function findAllPosts($isPaginated);

    /**
     * Should return a single blog post
     *
     * @param  int $id Identifier of the Post that should be returned
     * @return PostInterface
     */
    public function findPost($id);


    public function savePost($data);

    public function deletePost($data);
}