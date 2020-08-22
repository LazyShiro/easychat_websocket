<?php declare(strict_types = 1);

namespace App\WebSocket\IM;

use App\Common\WsMessage;
use app\data\enum\MemberEnum;
use App\Helper\MemoryTable;
use App\Model\Dao\MemberDao;
use App\Model\Service\FriendService;
use App\Model\Service\MemberService;
use Swoft\WebSocket\Server\Exception\WsServerException;
use Swoft\WebSocket\Server\Message\Message;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;
use Swoft\WebSocket\Server\Annotation\Mapping\MessageMapping;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class MemberController
 *
 * @WsController("member")
 */
class MemberController
{
    /**
     * @Inject()
     * @var MemberService
     */
    protected $memberService;

    /**
     * 编辑个签
     * @MessageMapping("editSignature")
     */
    public function editSignature(Message $message) : array
    {
        try {
            $data = $message->getData();

            if (!isset($data['uid']) || empty($data['uid'])) {
                return wsReturn(100002);
            }

            if (!isset($data['signature']) || empty($data['signature'])) {
                return wsReturn(100007);
            }

            $uid       = (int) de($data['uid']);
            $signature = removeXSS($data['signature']);

            if ($uid === 0) {
                return wsReturn(100002);
            }

            if ($this->memberService->userChangeSignature($uid, $signature) === 1) {
                return wsReturn(['signature' => $signature]);
            } else {
                return wsReturn(900004);
            }
        } catch (WsServerException $exception) {
            return wsReturn(900006, ['msg' => $exception->getMessage(), 'code' => $exception->getCode()]);
        }
    }

    /**
     * 改变在线状态
     * @MessageMapping("changeFettle")
     */
    public function changeFettle(Message $message) : array
    {
        try {
            $data = $message->getData();

            if (!isset($data['status']) || empty($data['status'])) {
                return wsReturn(100009);
            }

            $status = removeXSS($data['status']);
            $fd     = context()->getRequest()->getFd();

            $fettle = MemberEnum::getEnumCode($status);

            if ($fettle === - 1) {
                return wsReturn(100009);
            }

            /** @var MemoryTable $MemoryTable */
            $MemoryTable = bean('App\Helper\MemoryTable');
            /** @var MemberService $memberService */
            $memberService = bean('App\Model\Service\MemberService');

            $uid = $MemoryTable->get(MemoryTable::FD_TO_USER, (string) $fd, 'uid');
            $memberService->userChangeFettle($uid, $fettle);

            return wsReturn();
        } catch (WsServerException $exception) {
            return wsReturn(900006, ['msg' => $exception->getMessage(), 'code' => $exception->getCode()]);
        }
    }

}
