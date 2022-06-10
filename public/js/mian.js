function generatePasssword(lang=16,hour=1){
    let date = new Date();
    let duration = date.getTime() + (hour * 60 * 60 * 1000);
    let chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let password = "";

    for (var i = 0; i <= lang; i++) {
        let randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber + 1);
    }
    let arrKey=[];
    arrKey['key']=password;
    arrKey['secureKey']=duration+"::"+md5(password);
    return arrKey;
}

let scuk = '1654856081617::uWKD#B$yV3l3*37w9';

function isSecureJ(key){
    let cmpD = new Date;
    let arrScuk = scuk.split("::");
    if(arrScuk.length<=1){
        return false;
    }
    if(cmpD.getTime() > parseInt(arrScuk[0])){
        return false;
    }
    if(md5(key) != arrScuk[1]){
       return false;
    }
    return true;
}

console.log(isSecureJ("uWKD#B$yV3l3*37w9"));
