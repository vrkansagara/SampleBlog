<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 2:05 AM
 */

namespace SampleBlog\Mapper;

use SampleBlog\Model\PostInterface;

interface PostMapperInterface
{
    /**
     * @param int|string $id
     * @return PostInterface
     * @throws \InvalidArgumentException
     */
    public function find($id);

    /**
     * @return array|PostInterface[]
     */
    public function findAll($isPaginated);

    /**
     * @param $data
     * @return mixed
     */
    public function save($data);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}