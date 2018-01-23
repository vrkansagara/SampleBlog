<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 12:49 AM
 */

namespace SampleBlog\Service;

use SampleBlog\Mapper\PostMapperInterface;

class PostService implements PostServiceInterface
{

    /**
     * @var \SampleBlog\\Mapper\PostMapperInterface
     */
    protected $postMapper;

    /**
     * @param PostMapperInterface $postMapper
     */
    public function __construct(PostMapperInterface $postMapper)
    {
        $this->postMapper = $postMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function findAllPosts($isPaginated)
    {
        return $this->postMapper->findAll($isPaginated);
    }

    /**
     * {@inheritDoc}
     */
    public function findPost($id)
    {
        return $this->postMapper->find($id);
    }

    public function savePost($data)
    {
        $this->postMapper->save($data);
    }

    public function deletePost($data)
    {
        $this->postMapper->delete($data);
    }


}