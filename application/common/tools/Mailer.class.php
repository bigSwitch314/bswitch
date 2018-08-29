<?php

namespace Common\Tools;

use PHPMailer;

class Mailer
{
    public function sendMail($data)
    {
        $mail= new PHPMailer();
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.126.com';                        // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'qigliao@126.com';                 // SMTP username
        $mail->Password = '10086zxx';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;                                    // TCP port to connect to
        $mail->CharSet = "utf-8";                             //设置字符集编码
        $mail->setFrom('qigliao@126.com', '重庆勤鸟圈科技有限公司');
        // 接收邮件地址
        if (is_array($data['address'])) {
            foreach ($data['address'] as $k =>$v ) {
                $mail->addAddress($v);
            }
        } else {
            $mail->addAddress($data['address']);
        }

        //$mail->addAddress('chenyang522024645@qq.com', 'Joe User');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        // 附件路径
        $mail->addAttachment($data['attachments_path']);
        //$mail->addAttachment('D:\Phper.doc');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        // 邮件标题
        $mail->Subject = $data['subject'];
        // 邮件内容
        $mail->Body    = $data['mail_content'];
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if(!$mail->send()) {
            logw(date("Ymd",time())."邮件发送失败", 'payErrorAndwrtError');
         return false;
        } else {
            logw(date("Ymd",time())."邮件发送成功", 'payErrorAndwrtError');
            return true;
        }
    }

}