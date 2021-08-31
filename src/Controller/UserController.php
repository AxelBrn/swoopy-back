<?php

namespace App\Controller;

use App\Dto\AuthDto;
use App\Dto\UserDto;
use App\Entity\User;
use App\Models\RefreshCookie;
use App\Models\ResponseModel;
use App\Repository\UserRepository;
use App\Utils\JwtUtils;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\JsonContent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/api/v1/users", format="json")
 * @OA\Tag(name="Users")
 */
class UserController extends AbstractController
{
    /**
     * Create a user
     * @Route("", methods={"POST"})
     * @param UserDto $userDto
     * @param UserRepository $userRepository
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         ref=@Model(type=UserDto::class),
     *     )
     * )
     * @return Response
     */
    public function create(UserDto $userDto, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $response = new ResponseModel(null, Response::HTTP_BAD_REQUEST, 'Arguments is missing');
        if ($userDto->isBuild()) {
            $user = new User();
            $user->setEmail($userDto->email);
            $user->setUsername($userDto->username);
            $user->setPassword($hasher->hashPassword($user, $userDto->password));
            try {
                $em->persist($user);
                $em->flush();
                $response = new ResponseModel(null, Response::HTTP_CREATED, 'User created with successfully');
            } catch (Exception $e) {
                $response = new ResponseModel(null, Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            }
        }
        return $response;
    }
}
