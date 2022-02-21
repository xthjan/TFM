import { Prop, Schema, SchemaFactory, raw } from '@nestjs/mongoose';
import { Document } from 'mongoose';

export type UsuarioDocument = Usuario & Document;

@Schema()
export class Usuario {
  @Prop(
    raw({
      primerNombre: { type: String },
      segundoNombre: { type: String },
      primerApellido: { type: String },
      segundoApellido: { type: String },
    }),
  )
  nombre: Record<string, any>;
  @Prop()
  username: string;
  @Prop()
  password: string;
}

export const UsuarioSchema = SchemaFactory.createForClass(Usuario);
