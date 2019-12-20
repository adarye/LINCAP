export default class Auth{
    constructor(user){
        this.user = user
    }
    roles(){
        return this.user.rol.map(rol=>rol.cz1_id_rol)
    }
    isAdmin(){
       
       return this.roles().includes("Admin")
    }

}