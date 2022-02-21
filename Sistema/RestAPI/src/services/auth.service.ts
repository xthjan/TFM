import { Injectable, UnauthorizedException } from '@nestjs/common';

import { JwtService } from '@nestjs/jwt';
import { UsuarioDocument } from 'src/data/schemas/usuario.schema';
import { UsuarioService } from './usuarios.service';

@Injectable()
export class AuthService {
  constructor(
    private usuarioService: UsuarioService,
    private jwtService: JwtService,
  ) {}

  async validateUser(username: string, pass: string): Promise<any> {
    const user = await this.usuarioService.autenticate({
      username: username,
      password: pass,
    });
    if (user == null || user.password != pass) {
      throw new UnauthorizedException();
    }
    return this.login(user);
  }

  async login(user: UsuarioDocument) {
    const payload = { username: user.username, sub: user._id };
    return {
      access_token: this.jwtService.sign(payload),
    };
  }
}
