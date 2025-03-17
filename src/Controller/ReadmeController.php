<?php

declare(strict_types=1);

/**
 * Derafu: Derafu ORG Page.
 *
 * Copyright (c) 2025 Esteban De La Fuente Rubio / Derafu <https://www.derafu.org>
 * Licensed under the MIT License.
 * See LICENSE file for more details.
 */

namespace Derafu\Org\Controller;

use Derafu\Http\Contract\RequestInterface;
use Derafu\Renderer\Contract\RendererInterface;
use Derafu\Routing\Exception\RouteNotFoundException;

/**
 * Readme controller.
 */
class ReadmeController
{
    /**
     * List of readmes with their URIs.
     *
     * @var array<string,string>
     */
    private const READMES = [
        'escpos' => 'https://raw.githubusercontent.com/derafu/escpos/refs/heads/main/README.md',
        'vite-plugin-d2' => 'https://raw.githubusercontent.com/derafu/vite-plugin-d2/refs/heads/main/README.md',
        'l10n-cl-rut' => 'https://raw.githubusercontent.com/derafu/l10n-cl-rut/refs/heads/main/README.md',
        'l10n-cl-enum' => 'https://raw.githubusercontent.com/derafu/l10n-cl-enum/refs/heads/main/README.md',
        'enum' => 'https://raw.githubusercontent.com/derafu/enum/refs/heads/main/README.md',
        'docker-php-caddy-server' => 'https://raw.githubusercontent.com/derafu/docker-php-caddy-server/refs/heads/main/README.md',
        'deployer' => 'https://raw.githubusercontent.com/derafu/deployer/refs/heads/main/README.md',
        'github' => 'https://raw.githubusercontent.com/derafu/github/refs/heads/main/README.md',
    ];

    /**
     * Constructor.
     *
     * @param RendererInterface $renderer Renderer service.
     */
    public function __construct(private readonly RendererInterface $renderer)
    {
    }

    /**
     * Show a readme.
     *
     * @param RequestInterface $request Request.
     * @param string $readme Readme name.
     * @return string Rendered readme.
     */
    public function show(RequestInterface $request, string $readme): string
    {
        $readmeUri = self::READMES[$readme] ?? null;
        if (!$readmeUri) {
            throw new RouteNotFoundException($request->getUri()->getPath());
        }

        $readmeMd = @file_get_contents($readmeUri);
        if (!$readmeMd) {
            throw new RouteNotFoundException($request->getUri()->getPath());
        }

        return $this->renderer->render('markdown.html.twig', [
            'content' => $readmeMd,
        ]);
    }
}
