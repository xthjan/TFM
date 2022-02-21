import { Module } from '@nestjs/common';
import { MongooseModule } from '@nestjs/mongoose';
import { UsuarioController } from './controllers/usuario.controller';
import { Usuario, UsuarioSchema } from './data/schemas/usuario.schema';
import { UsuarioService } from './services/usuarios.service';
import { ConfigModule } from '@nestjs/config';
import { AuthService } from './services/auth.service';
import { JwtModule } from '@nestjs/jwt';
import { jwtConstants } from './auth/constants';
import { AuthorizationController } from './controllers/auth.controler';
import { JwtStrategy } from './auth/auth.jwt.strategy';
import { APP_GUARD } from '@nestjs/core';
import { JwtAuthGuard } from './auth/auth.jwt.guard';

@Module({
  imports: [
    MongooseModule.forRoot('mongodb://localhost/ApostillaMatic'),
    MongooseModule.forFeature([{ name: Usuario.name, schema: UsuarioSchema }]),
    ConfigModule.forRoot(),
    JwtModule.register({
      secret: jwtConstants.secret,
      signOptions: { expiresIn: '60s' },
    }),
  ],
  controllers: [UsuarioController, AuthorizationController],
  providers: [
    UsuarioService,
    AuthService,
    JwtStrategy,
    {
      provide: APP_GUARD,
      useClass: JwtAuthGuard,
    },
  ],
})
export class AppModule {}
