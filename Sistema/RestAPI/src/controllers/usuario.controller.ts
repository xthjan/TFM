import { Controller } from '@nestjs/common';
import { UsuarioDocument } from 'src/data/schemas/usuario.schema';
import { UsuarioService } from 'src/services/usuarios.service';
import { BaseController } from './base/base.controller';

@Controller('/usuarios')
export class UsuarioController extends BaseController<
  UsuarioDocument,
  UsuarioService
> {
  constructor(private readonly usuarioService: UsuarioService) {
    super(usuarioService);
  }
}
