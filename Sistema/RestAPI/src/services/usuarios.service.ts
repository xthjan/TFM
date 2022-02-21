import { Injectable, InternalServerErrorException } from '@nestjs/common';
import { InjectModel } from '@nestjs/mongoose';
import { FilterQuery, Model } from 'mongoose';
import { Usuario, UsuarioDocument } from '../data/schemas/usuario.schema';
import { GenericService } from './generic/generic.service';

@Injectable()
export class UsuarioService extends GenericService<UsuarioDocument> {
  constructor(
    @InjectModel(Usuario.name) readonly usersModel: Model<UsuarioDocument>,
  ) {
    super(usersModel);
  }
  async autenticate(
    conditions: Partial<Record<keyof UsuarioDocument, unknown>>,
  ): Promise<UsuarioDocument> {
    try {
      return await this.model.findOne(
        conditions as FilterQuery<UsuarioDocument>,
      );
    } catch (err) {
      this.serviceLogger.error(`Could not find ${this.modelName} entry:`);
      this.serviceLogger.error(err);
      throw new InternalServerErrorException();
    }
  }
}
