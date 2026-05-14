<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Signup</title>

    <link rel="stylesheet"
          href="../assets/style.css">
</head>

<body>

<div class="container">

    <h1>Create Account</h1>

    <form id="signupForm">

        <input type="text"
               name="full_name"
               placeholder="Full Name"
               required>

        <input type="email"
               name="email"
               placeholder="Email"
               required>

        <input type="text"
               name="phone"
               placeholder="Phone"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <select name="role">

            <option value="user">
                User
            </option>

            <option value="electrician">
                Electrician
            </option>

            <option value="admin">
                Admin
            </option>

        </select>

        <button type="submit">
            Send OTP
        </button>

    </form>

    <div id="otpBox"
         style="display:none; margin-top:20px;">

        <input type="text"
               id="otp"
               placeholder="Enter OTP">

        <button onclick="verifyOTP()">
            Verify OTP
        </button>

    </div>

    <div id="msg"></div>

    <p>
        Already have account?
        <a href="login.php">Login</a>
    </p>

</div>

<script>

let formData;

document
.getElementById("signupForm")
.onsubmit = async (e) => {

    e.preventDefault();

    formData = new FormData(e.target);

    const res = await fetch(
        "../actions/send_otp.php",
        {
            method: "POST",
            body: formData
        }
    );

    const data = await res.json();

    document
    .getElementById("msg")
    .innerHTML = data.message;

    if(data.status === "success"){

        document
        .getElementById("otpBox")
        .style.display = "block";

    }

};

async function verifyOTP(){

    formData.set(
        "otp",
        document.getElementById("otp").value
    );

    const res = await fetch(
        "../actions/verify_otp.php",
        {
            method: "POST",
            body: formData
        }
    );

    const data = await res.json();

    document
    .getElementById("msg")
    .innerHTML = data.message;

    if(data.status === "success"){

        setTimeout(() => {

            window.location = "login.php";

        }, 1000);

    }

}

</script>

</body>
</html>