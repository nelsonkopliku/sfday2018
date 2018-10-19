<?php

declare(strict_types=1);

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      collectionOperations={
 *          "post"={
 *              "path"="/users/forgot-password-request",
 *          },
 *      },
 *      itemOperations={},
 * )
 */
final class ForgotPasswordRequest
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $email;
}