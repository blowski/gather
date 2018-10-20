<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;
    /**
     * @var GuardAuthenticatorHandler
     */
    private $guardAuthenticatorHandler;
    /**
     * @var LoginFormAuthenticator
     */
    private $loginFormAuthenticator;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->guardAuthenticatorHandler = $guardAuthenticatorHandler;
        $this->loginFormAuthenticator = $loginFormAuthenticator;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        // intentionally left blank
    }

    /**
     * @Route("/register", name="register", methods={"GET","POST"})
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user, [
            'action' => $this->generateUrl('register'),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getPassword()));

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->guardAuthenticatorHandler->authenticateUserAndHandleSuccess($user, $request, $this->loginFormAuthenticator, 'main');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}