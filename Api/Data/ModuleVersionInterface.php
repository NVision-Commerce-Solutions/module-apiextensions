<?php

namespace Commerce365\MagentoApiExtensions\Api\Data;

interface ModuleVersionInterface
{
    /**
     * @return string
     */
    public function getModule(): string;

    /**
     * @param string $module
     * @return $this
     */
    public function setModule(string $module);

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version);

}
