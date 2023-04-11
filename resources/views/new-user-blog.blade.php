<div style="width: 600px; margin: 0 auto; " >
    <div style="text-align: center">
        <h2> hi, {{ $name }}</h2>
        <p>You have registered at the website laraBlog</p>
        <p>To be able to use the services, please click the button below to activate your account</p>
   
        <p>
            <a href="{{ route('active-account-user',['token'=>$token,'email'=>$email ]) }}" style="display: inline-block; background: green;color: #fff;padding: 7px 25px; font-weight: bold">Active Account</a>
        </p>
    </div>

</div>