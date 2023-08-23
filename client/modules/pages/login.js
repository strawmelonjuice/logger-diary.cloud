const helga = function () {
    var astrid = `
     <form id="loginform" action="#/gologin/" method="get">
            <div class="form-group">
                <label><h4>Username</h4></label>
                <input type="text" name="username" id="username-input" class="LoginForm " value="Just_Mar_Ok">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label><h4>Password</h4></label>
                <input type="password" name="password" id="password-input" class="LoginForm " value="xxosihH8riEq7c">
                <span class="invalid-feedback"></span>
            </div>
                <div class="form-group">
                      <input type="checkbox" name="autologin" value="1">
                      <label for="autologin"> Stay logged in <small style="font-size: 8px">Let cookies do the job for you</small></label><br>
                </div>
                <div class="form-group"><br></br>
                <input type="submit" class="LoginForm LoginButton" value="Continue!">
            </div>
            <p>Don't have an account? <a href="https://logger-diary.online/register/" target="_popup">Sign up online</a>.</p>
        </form>
    `
    return astrid;
}
export default helga