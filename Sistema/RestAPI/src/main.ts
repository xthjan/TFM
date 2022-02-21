import { NestFactory } from '@nestjs/core';
import { NestExpressApplication } from '@nestjs/platform-express';
import { AppModule } from './app.module';

async function bootstrap() {
  const app = await NestFactory.create<NestExpressApplication>(AppModule, {
    logger: console,
  });
  app.disable('x-powered-by');
  await app.listen(parseInt(process.env.PORT_ENV) || 3000);
}
bootstrap();
