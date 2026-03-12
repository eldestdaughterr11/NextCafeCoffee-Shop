const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

async function main() {
  console.log('Creating Admin User...');
  const admin = await prisma.user.upsert({
    where: { email: 'admin@nextcafe.com' },
    update: {},
    create: {
      name: 'Admin NextCafe',
      username: 'admin',
      email: 'admin@nextcafe.com',
      password: 'password123',
      role: 'admin'
    }
  });

  console.log('Creating Customer User...');
  const customer = await prisma.user.upsert({
    where: { email: 'user@example.com' },
    update: {},
    create: {
      name: 'John Coffee',
      username: 'john',
      email: 'user@example.com',
      password: 'password123',
      role: 'customer'
    }
  });

  console.log('Users seeded successfully!');
}

main()
  .catch((e) => console.error(e))
  .finally(async () => await prisma.$disconnect());
