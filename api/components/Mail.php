<?php

namespace api\components;


/**
 * Extend Active Controller.  All controllers for the API should extend from here.
 */
class Mail
{

    public static function Send($from, $attachment)
    {
        $to = \Yii::$app->params['adminEmail'];
        $fromName = 'New Attachment';
        $subject = \Yii::$app->params['subject_attachment'];
        $file = \Yii::getAlias('@frontend') . '/web/attachments/' . $attachment;
        $htmlContent = '';
        $headers = "From: $fromName" . " <" . $from . ">";
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";
        if (!empty($file) > 0) {
            if (is_file($file)) {
                $message .= "--{$mime_boundary}\n";
                $fp = @fopen($file, "rb");
                $data = @fread($fp, filesize($file));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: image/jpeg; name=\"" . basename($file) . "\"\n" .
                    "Content-Description: " . basename($file) . "\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
        }
        $message .= "--{$mime_boundary}--";
        $returnpath = "-f" . $from;
        return @mail($to, $subject, $message, $headers, $returnpath);
    }

}