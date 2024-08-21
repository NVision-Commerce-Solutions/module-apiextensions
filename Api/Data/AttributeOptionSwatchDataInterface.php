<?php

namespace Commerce365\MagentoApiExtensions\Api\Data;

/**
 * Interface AttributeOptionSwatchDataInterface
 * @api
 * @since 100.0.2
 */
interface AttributeOptionSwatchDataInterface
{
    const COLOR = 'color';

    const FILE = 'file';

    const FILENAME = 'filename';

    /**
     * Get color
     *
     * @return string|null
     */
    public function getColor();

    /**
     * Set color
     *
     * @param string $color
     * @return $this
     */
    public function setColor($color);

    /**
     * Get file
     *
     * @return string|null
     */
    public function getFile();

    /**
     * Set file
     *
     * @param string $file
     * @return $this
     */
    public function setFile($file);

    /**
     * Get file name
     *
     * @return string|null
     */
    public function getFilename();

    /**
     * Set file name
     *
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename);
}
