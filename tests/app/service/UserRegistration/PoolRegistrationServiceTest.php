<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use PangzLab\App\Model\User\JoiningUser;
use PangzLab\App\Service\DatabaseService;
use PangzLab\App\Service\DatabaseTransaction\DatabaseTransactionService;
use PangzLab\App\Service\UserRegistration\PoolRegistrationService;
use PangzLab\App\Repository\User\PoolUserRepo;

final class PoolRegistrationServiceTest extends TestCase
{
    protected static $registrationService;
    protected static $validUser;
    protected static $dbTransaction;
    protected static $tempUserRepo;

    public static function setUpBeforeClass()
    {
        //Create MOCK for DatabaseTransactionService
        //Disconnect DB Connection - create stub
        static::$dbTransaction = new DatabaseTransactionService(new DatabaseService());
        static::$registrationService = new PoolRegistrationService(static::$dbTransaction);
        static::$tempUserRepo = new PoolUserRepo(static::$dbTransaction);
        static::$validUser = new JoiningUser([
            "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
            "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
            "emailAddress"  => "jerold@gmail.com",
            "secretWords"   => ["test1", "test2", "test3"],
            "status"        => 1
        ]);
    }

    /**
     * @dataProvider userListDataProvider
     */
    public function testInputCanBeValidated($expected, $user): void
    {
        $this->assertSame($expected, static::$registrationService->isAllowed($user));
    }

    public function testCanRegisterTemporaryUser(): void
    {
        $registeredId = static::$registrationService->register(static::$validUser);
        $newUser = static::$tempUserRepo->getById($registeredId)[0];
        $this->assertIsInt($registeredId);
        $this->assertEquals(static::$validUser->getPublicAddress(), $newUser->getPublicAddress());
        $this->assertEquals(static::$validUser->getWalletAddress(), $newUser->getWalletAddress());
        $this->assertEquals(static::$validUser->getEmailAddress(), $newUser->getEmail());
        static::$tempUserRepo->deleteById($registeredId);
    }

    public function userListDataProvider()
    {
        return [
            "default user" => [
                false,
                new JoiningUser([])
            ],
            "empty user" => [
                false,
                new JoiningUser([
                    "publicAddress" => "",
                    "walletAddress" => "",
                    "emailAddress"  => "",
                    "secretWords"   => [],
                    "status"        => ""
                ])
            ],
            "all null user" => [
                false,
                new JoiningUser([
                    "publicAddress" => null,
                    "walletAddress" => null,
                    "emailAddress"  => null,
                    "secretWords"   => null,
                    "status"        => null,
                ])
            ],
            "no public addres" => [
                false,
                new JoiningUser([
                    "publicAddress" => "",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => ["test1", "test2", "test3"],
                    "status"        => 1
                ])
            ],
            "no wallet Id" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => ["test1", "test2", "test3"],
                    "status"        => 1
                ])
            ],
            "no email address" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "",
                    "secretWords"   => ["test1", "test2", "test3"],
                    "status"        => 1
                ])
            ],
            "not formatted email address" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "",
                    "secretWords"   => ["test1", "test2", "test3"],
                    "status"        => 1
                ])
            ],
            "no secret words" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => [],
                    "status"        => 1
                ])
            ],
            "short secret words" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => ["test2"],
                    "status"        => 1
                ])
            ],
            "non unique secret words" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => ["test2", "test2", "test2"],
                    "status"        => 1
                ])
            ],
            "short secret words" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => ["tes1", "tes2", "tes3"],
                    "status"        => 1
                ])
            ],
            "null status" => [
                false,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => ["test1", "test2", "test3"],
                    "status"        => null
                ])
            ],
            "valid user" => [
                true,
                new JoiningUser([
                    "publicAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk4h5jkfasdfd234jk",
                    "walletAddress" => "5234n3jk45sfcdfercdrre5234jkl5h3jk",
                    "emailAddress"  => "jerold@gmail.com",
                    "secretWords"   => ["test1", "test2", "test3"],
                    "status"        => 1
                ])
            ],
        ];
    }
}