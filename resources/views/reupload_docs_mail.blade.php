<html>
    <head>
        <!-- <link rel="stylesheet" href="{{ asset('css/email_style.css') }}"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        @vite(['storage/app/public/css/email_style.css'])
    </head>
    <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; font-weight: 500;'>
        <div style='background-color: white; border-radius: 10px; width: 100%; max-width: 600px; margin: 20px auto; text-align: left;'>
            <div style='background-color: #161a39; align-items: center; text-align: center; padding: 20px;'>
                <img src="{{ Vite::asset('storage/images/lockreload.png') }}" alt="">
                <h3 style='color: white; font-size: 20px;'>Reupload Vehicle Registration Documents</h3>
            </div>
            <div style='padding: 40px;'>
                <p style='margin: 10px 0; color: #666666; font-size: 14px;'>Hello, <span>{{ $user->vehicle_owner->fname }}</span>!</p>
                <p style='margin: 10px 0; color: #666666; font-size: 14px;'>Please reupload the following documents</p>
                    <ul>
                        @foreach($filesToReupload as $file)
                            <li>{{ $file }}</li>
                        @endforeach
                    </ul>
                <p style='margin: 10px 0; color: #666666; font-size: 14px;'>If you have any questions or need further assistance, please don't hesitate to contact us at <a href='mailto:businabicoluniversity@gmail.com'>businabicoluniversity@gmail.com</a>.</p>
                <p style='margin: 10px 0; color: #666666; font-size: 14px;'>Best regards,<br><span>Bicol University BUsina</span></p>
            </div>
            <div style='background-color: #161a39; padding: 20px 20px 5px 20px;'>
                <div style='color: #f4f4f4; font-size: 12px;'>
                    <p><span style='font-size: 14px; font-weight: 600;'>Contact</span></p>
                    <p>businabicoluniversity@gmail.com</p>
                    <p>Legazpi City , Albay , Philippines 13°08′39″N 123°43′26″E</p>
                </div>
                <div style='text-align: center;'>
                    <p style='color: #f4f4f4; font-size: 14px;'>Company ©  All Rights Reserved</p>
                </div>
            </div>
        </div>
    </body>
</html>